import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CreateTagComponent } from './create-tag.component';

describe('CreateTagComponent', () => {
  let component: CreateTagComponent;
  let fixture: ComponentFixture<CreateTagComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [CreateTagComponent]
    });
    fixture = TestBed.createComponent(CreateTagComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
