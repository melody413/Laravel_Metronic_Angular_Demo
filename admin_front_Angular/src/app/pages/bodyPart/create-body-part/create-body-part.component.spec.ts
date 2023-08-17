import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CreateBodyPartComponent } from './create-body-part.component';

describe('CreateBodyPartComponent', () => {
  let component: CreateBodyPartComponent;
  let fixture: ComponentFixture<CreateBodyPartComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [CreateBodyPartComponent]
    });
    fixture = TestBed.createComponent(CreateBodyPartComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
